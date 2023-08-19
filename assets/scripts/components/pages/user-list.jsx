import React from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import UserForm from '../forms/user-form.jsx';
import { t } from 'i18next';

export default class Registration extends React.Component {
	
	constructor(props) {
		super(props);
		this.state = {
			users: [],
			editUserModalShown: false,
			editedUser: null,
			editedUserErrors: {},
		};
	}

  async handleSubmit(self, event) {
  	event.preventDefault();
    
    let formData = new FormData(event.target);
    self.setState({ editedUserErrors: {} });
    axios.post('/api/user/' + self.state.editedUser?.id, formData)
    	.then(response => {
    		alert(t('pages.userList.userUpdateSuccessAlert'));
    		let users = self.state.users;
    		let newUser = response.data;
    		users = users.map(u => u.id == self.state.editedUser.id ? newUser : u);
				self.setState({ 
					users: users,
					editUserModalShown: false,
				});
    	})
    	.catch(error => {
    		self.setState({ editedUserErrors: error.response.data });
    	});
  }

	componentDidMount() {
		axios.get('/api/user/')
			.then(response => {
				console.log(response)
				this.setState({ users: response.data })
			})
	}

  showEditUserModal(self, user) {
  	self.setState({
  		editUserModalShown: true,
  		editedUser: user,
  	});
  }

  hideEditUserModal(self) {
  	self.setState({
  		editUserModalShown: false,
  	});
  }

  deleteUser(self, user) {
  	axios.delete('/api/user/' + user.id)
    	.then(response => {
    		alert(t('pages.userList.userDeleteSuccessAlert'));
				self.setState({ 
					users: self.state.users.filter(u => u.id != user.id),
				});
    	})
    	.catch(error => {
    		alert(t('pages.userList.userDeleteFailureAlert'));
    	});
  }

  showYesOrNo(value) {
  	if (value === true) {
  		return t('general.yes');
  	} else if (value === false) {
  		return t('general.no');
  	} else {
  		return '';
  	}
  }

	render() {
		return (
			<>
				<h1>{t('pages.userList.mainHeader')}</h1>

				<table className="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>{t('user.login')}</th>
							<th>{t('user.name')}</th>
							<th>{t('user.surname')}</th>
							<th>{t('user.email')}</th>
							<th>{t('user.description')}</th>
							<th>{t('user.job')}</th>
							<th>{t('user.projectManagementMethodologies')}</th>
							<th>{t('user.reportSystems')}</th>
							<th>{t('user.knowsScrum')}</th>
							<th>{t('user.testingSystems')}</th>
							<th>{t('user.knowsSelenium')}</th>
							<th>{t('user.programmingLanguages')}</th>
							<th>{t('user.ideEnvironments')}</th>
							<th>{t('user.knowsMySQL')}</th>
							<th>{t('general.actions')}</th>
						</tr>
					</thead>
					<tbody>
						{this.state.users.map(u => (
							<tr key={u.id} data-user-property="id" id={'user-'+u.id} data-user={(user => {
								// Delete user description, because it may long andd we don't want to store it in JSON
								delete user['description'];

								return JSON.stringify(user);
							})(u)}>
								<td>{u.login}</td>
								<td>{u.name}</td>
								<td>{u.surname}</td>
								<td>{u.email}</td>
								<td className="user-description">{u.description}</td>
								<td>{u.job}</td>
								<td>{u.projectManagementMethodologies || ''}</td>
								<td>{u.reportSystems || ''}</td>
								<td>{this.showYesOrNo(u.knowsScrum)}</td>
								<td>{u.testingSystems || ''}</td>
								<td>{this.showYesOrNo(u.knowsSelenium)}</td>
								<td>{u.programmingLanguages || ''}</td>
								<td>{u.ideEnvironments || ''}</td>
								<td>{this.showYesOrNo(u.knowsMySQL)}</td>
								<td>
						      <Button variant="primary" onClick={event => {
						      	let row = event.target.closest('tr');
						      	let user = JSON.parse(row.dataset.user);
						      	user['description'] = row.querySelector('.user-description').innerText;

						      	this.showEditUserModal(this, user)
						      }}>
						        {t('general.edit')}
						      </Button>
									<button onClick={() => this.deleteUser(this, u)} className="btn btn-danger">
										{t('general.delete')}
									</button>
								</td>
							</tr>
						))}
					</tbody>
				</table>

	      <Modal show={this.state.editUserModalShown} onHide={() => this.hideEditUserModal(this)}>
	        <Modal.Header closeButton>
	          <Modal.Title>Modal heading</Modal.Title>
	        </Modal.Header>
	        <Modal.Body>
	        	<UserForm user={this.state.editedUser} errors={this.state.editedUserErrors} onSubmit={event => this.handleSubmit(this, event)} />
	        </Modal.Body>
	      </Modal>
			</>
		);
	}
}