import {combineReducers} from 'redux';
import users from './users/reducer';

export const IndexReducer = combineReducers({
  //aquí importamos y llamamos el users/reducer.js creado anteriormente
  //si esto no se hace no funcionará el reducer
  users,
});
