import React from 'react';
import { useSelector, useDispatch } from 'react-redux';
import {getUsersAttempt} from './../../redux/users/actions';

const Example = () => {
	const dispatch = useDispatch();
  	//De esta manera accedemos al estado users que creamos anteriormente en src/redux/users/reducer.js
  	const users = useSelector(state => state.users); 

  	const handleRequestAPI = () => {
  		dispatch(getUsersAttempt('token falso para este ejemplo'));
  	};

  	return (
  		<div>
          	<p>App example jeje</p>
          	<button onClick={() => {
          		handleRequestAPI();
          	}}>
          		{users.requesting ? 'Cargando ...' : 'Traer Datos'}
          	</button>
          	{users.users.map(user => {
          		return (
          			<div key={user.id}>
          				<p>{user.name}</p>
          			</div>
          		);
          	})}
        </div>
  	);
};

export default Example;