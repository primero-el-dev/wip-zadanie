import React from 'react';
import InputControl from '../inputs/input-control.jsx';
import TextareaControl from '../inputs/textarea-control.jsx';
import CheckboxControl from '../inputs/checkbox-control.jsx';
import Button from './button.jsx';
import { t } from 'i18next';

export default class UserForm extends React.Component {

	render() {
		return (
			<form onSubmit={this.props.onSubmit}>
				<InputControl label={t('user.login')} name="login" required />
				<InputControl label={t('user.password')} name="password" type="password" error={this.props.error} required />

				<Button text={t('general.submit')} type="submit" classes="btn-success" />
			</form>
		);
	}
}