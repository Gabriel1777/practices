import {all, fork} from 'redux-saga/effects';
import UsersSagas from './users/sagas';

export function* IndexSagas() {
  yield all([
    //aquí importamos y llamamos el users/sagas.js creado anteriormente
    //si esto no se hace no funcionará el middleware
    fork(UsersSagas),
  ]);
}
