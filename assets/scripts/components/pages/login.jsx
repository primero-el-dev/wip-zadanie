import React from 'react';
import { Navigate } from 'react-router-dom';
import LoginForm from '../forms/login-form.jsx';
import axios from 'axios';
import { t } from 'i18next';
import { setLoggedUser } from '../../functions.js';

export default class Login extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			loginError: null,
			loggedIn: false,
		};
	}

  handleSubmit(self, event) {
  	event.preventDefault();
  	self.setState({ loginError: null });

    let formData = new FormData(event.target);
    axios.post('/api/login', formData)
    	.then(response => {
				setLoggedUser(response.data);

				window.location.href = '/home';
    	})
    	.catch(error => {
    		self.setState({ loginError: error.response.data?.error || null });
    	});
  }

	render() {
		return (
			<>
				<h1>{t('pages.login.mainHeader')}</h1>

				<LoginForm onSubmit={event => this.handleSubmit(this, event)} error={this.state.loginError} />

				{this.state.loggedIn && (<Navigate to="/home" />)}
			</>
		);
	}
}