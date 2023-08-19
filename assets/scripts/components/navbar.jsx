import React from 'react';
import * as ReactDOM from 'react-dom/client';
import {
  NavLink,
  Navigate,
} from 'react-router-dom';
import axios from 'axios';
import { t } from 'i18next';
import { isUserLogged, isLoggedUserAndHasRole, logout, getLoggedUserRoles } from '../functions.js';

export default class Navbar extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			isUserLogged: isUserLogged(),
			loggedUserRoles: getLoggedUserRoles(),
		};
	}

	logout(self) {
		axios.post('/api/logout')
			.then(response => {
				logout();
				
				window.location.href = '/login';
			});
	}

	render() {
		return (
	    <nav className="navbar navbar-expand-sm navbar-light bg-light">
	      <div className="container-fluid">
	        <a className="navbar-brand" href="#">{t('general.appName')}</a>
	        <button 
	          className="navbar-toggler" 
	          type="button" 
	          data-bs-toggle="collapse" 
	          data-bs-target="#navbarSupportedContent" 
	          aria-controls="navbarSupportedContent" 
	          aria-expanded="false" 
	          aria-label="Toggle navigation"
	        >
	          <span className="navbar-toggler-icon"></span>
	        </button>
	        <div className="collapse navbar-collapse" id="navbarSupportedContent">
	          <ul className="navbar-nav ms-auto mb-2 mb-lg-0">
	            {this.state.isUserLogged || (
	              <li className="nav-item">
	              	<NavLink className="nav-link" to="/">{t('navbar.home')}</NavLink>
	              </li>
	            )}
	            {this.state.isUserLogged || (
	              <li className="nav-item">
	              	<NavLink className="nav-link" to="/login">{t('navbar.login')}</NavLink>
	              </li>
	            )}
	            {this.state.loggedUserRoles.filter(r => r == 'ROLE_ADMIN').length > 0 && (
	              <li className="nav-item">
	                <NavLink className="nav-link" to="/admin">{t('navbar.userList')}</NavLink>
	              </li>
	            )}
	            {this.state.isUserLogged && (
	              <li className="nav-item">
	                <a className="nav-link" style={{'cursor':'pointer'}} onClick={() => this.logout(this)}>{t('navbar.logout')}</a>
	              </li>
	            )}
	          </ul>
	        </div>
	      </div>
	    </nav>
		);
	}
}