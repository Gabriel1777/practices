import {
	GET_USERS_ATTEMPT,
	GET_USERS_SUCCESS,
	GET_USERS_FAILURE,
} from './constants';

export const getUsersAttempt = (token) => ({
	type: GET_USERS_ATTEMPT,
	token 
});

export const getUsersSuccess = (users) => ({
	type: GET_USERS_SUCCESS,
	users 
});

export const getUsersFailure = (error) => ({
	type: GET_USERS_FAILURE,
	error
});