import React from 'react';
import { redirect } from 'react-router-dom';
import UserForm from '../forms/user-form.jsx';
import axios from 'axios';
import { t } from 'i18next';

export default class UserCreate extends React.Component {
	
	constructor(props) {
		super(props);
		this.state = {
			errors: {},
		};
	}

  async handleSubmit(self, event) {
  	event.preventDefault();
    
    let formData = new FormData(event.target);
    self.setState({ errors: {} });
    axios.post('/api/user/', formData)
    	.then(response => {
    		alert(t('pages.userCreate.successAlert'));
    	})
    	.catch(error => {
    		self.setState({ errors: error.response.data });
    	});
  }

	render() {
		return (
			<>
				<h1>{t('pages.userCreate.mainHeader')}</h1>

				<UserForm user={null} errors={this.state.errors} onSubmit={event => this.handleSubmit(this, event)} />
			</>
		);
	}
}