import React from 'react';
import {
	View,
	Text,
	Button
} from 'react-native';
import { useSelector, useDispatch } from 'react-redux';
import {getUsersAttempt} from './../../redux/users/actions';

const Example = () => {
	const dispatch = useDispatch();
  	const users = useSelector(state => state.users); 

  	const handleRequestAPI = () => {
  		dispatch(getUsersAttempt('token falso para este ejemplo'));
  	};

  	return (
  		<View>
          	<Text>App example</Text>
          	<Button 
          		title={users.requesting ? 'Cargando ...' : 'Traer Datos'}
          		onPress={() => {
          			handleRequestAPI();
          		}}
          	/>
          	{users.users.map(user => {
          		return (
          			<View key={user.id}>
          				<Text>{user.name}</Text>
          			</View>
          		);
          	})}
        </View>
  	);
};

export default Example;