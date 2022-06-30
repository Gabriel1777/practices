import {
  GET_USERS_ATTEMPT,
  GET_USERS_SUCCESS,
  GET_USERS_FAILURE,
} from './constants';

const initialState = {
  requesting: false,
  success: false,
  error: '',
  users: []
};

const reducer = (state = initialState, action) => {
  switch (action.type) {
    // cuando se dispare esta acción cambiamos las variables del estado para indicar
    //que se esta haciendo una petición por eso ponemos el requesting: true
    case GET_USERS_ATTEMPT:
      return {
        ...state,
        requesting: true,
        success: false,
        error: '',
      };
    // cunado se dispare esta acción cambiamos las variables del estado para indicar
    //que la petición fue todo un exito por eso ponemos el success: true y requesting: false
    case GET_USERS_SUCCESS:
      return {
        ...state,
        requesting: false,
        success: true,
        error: '',
        //recivimos la lista que nos devuelve la api y la guerdamos en el arreglo users del estado
        users: action.users
      };
    // cuando se dispare esta acción cambiamos las variables del estado para indicar
    //que la petición ha fallado y asignamos error: 'el mensaje de error que nos envia la acción'
    case GET_USERS_FAILURE:
      return {
        ...state,
        requesting: false,
        success: false,
        error: action.error
      };
    default:
      return state;
  }
};

export default reducer;
