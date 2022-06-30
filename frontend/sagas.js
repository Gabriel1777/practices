import {call, all, put, takeEvery} from 'redux-saga/effects';
import {
  getUsersSuccess,
  getUsersFailure
} from './actions';
import {
  GET_USERS_ATTEMPT
} from './constants';


//para este ejemplo declaramos esta variable en este archivo
//pero esta variable siempre debe ser exportada de utils/constants.js
const ROUTE_ENDPOINT = "https://api.instasharemaster.com/api/v1";

const getUsersAPI = (token) => {
  return fetch(`${ROUTE_ENDPOINT}/category`, {
    method: 'GET',
    headers: {
      'Authorization': 'Bearer ' + token,
      'Content-Type': 'application/json',
    },
    //body: JSON.stringify({id: 1}),
  })
    .then(response => response.json())
    .then(json => {
      if (json.code !== 200) 
        throw json.data; //En caso de que la API devuelva un código diferente al 200 se lanza la excepción para notificar el error
      else
        return json.data.data; //El código que envio l API es 200 retornamos la coleción de datos devuelta por la API.
    })
    .catch(error => {
      throw error;
    });
};

function* getUsersFlow(action) {
  try {
    //obtener las variables enviadas por la acción
    const {token} = action;
    //ejecutar la petición a la API enviando las variables pasadas por la acción
    const users = yield call(getUsersAPI, token);
    //despachamos la acción de exito y enviamos la lista de usuarios que nos llego de la API para guardarla en el estado
    yield put(getUsersSuccess(users));
  } catch (error) {
    //despachamos la acción de error para notificar en el estado de que no se pudo obtener la lista de usuarios y enviamos 
    //dicho error atravez de la acción para estar informadados del error especifico.
    yield put(getUsersFailure(error));
  }
}

function* usersWatcher() {
  yield all([
    //Cada vez que un componente despache esta acción se ejecutará el metodo getUsersFlow
    takeEvery(GET_USERS_ATTEMPT, getUsersFlow),
  ]);
}

export default usersWatcher;
