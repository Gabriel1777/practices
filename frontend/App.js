import {Provider} from 'react-redux';
import Example from './views/example';
import React, {Component} from 'react';
import createSagaMiddleware from 'redux-saga';
import {IndexSagas} from './redux/index-sagas';
import {IndexReducer} from './redux/index-reducer';
import {applyMiddleware, compose, createStore} from 'redux';


//creamos la instancia del middleware de redux-saga
const sagaMiddleware = createSagaMiddleware();
const composeSetup = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const store = createStore(
    //Creamos la tienda de la aplicación utilizando el combineReducers para 
    //Convertir todos los estados en uno solo
    IndexReducer,
    //agregamos el middleware de redux-saga a la tienda
    composeSetup(applyMiddleware(sagaMiddleware)),
);


//Ejecutamos el middleware para que se haga efectivo
sagaMiddleware.run(IndexSagas);

const App = () => {
  return (
    <div>
      {/* Encerramos la aplicación */}
      <Provider store={store}>
        <Example/>
      </Provider>
    </div>
  );
};

export default App;