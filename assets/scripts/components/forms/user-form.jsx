import React from 'react';
import InputControl from '../inputs/input-control.jsx';
import TextareaControl from '../inputs/textarea-control.jsx';
import CheckboxControl from '../inputs/checkbox-control.jsx';
import Button from './button.jsx';
import { t } from 'i18next';

export default class UserForm extends React.Component {
	
	constructor(props) {
		super(props);
		this.state = {
			user: props.user || { job: 'tester' },
		};
	}

	updateUserProperty(self, property, value) {
		let user = self.state.user;
		user[property] = value;
		self.setState({ user: user });
	}

	render() {
		return (
			<form onSubmit={this.props.onSubmit}>
				<InputControl 
					label={t('user.name')} 
					name="name" 
					value={this.state.user?.name || ''} 
					onChange={e => this.updateUserProperty(this, 'name', e.target.value)} 
					min="1" 
					max="40" 
					required 
					error={this.props.errors?.name || ''}
				/>
				<InputControl 
					label={t('user.surname')}
					name="surname" 
					value={this.state.user?.surname || ''} 
					onChange={e => this.updateUserProperty(this, 'surname', e.target.value)} 
					min="2" 
					max="100" 
					required 
					error={this.props.errors?.surname || ''}
				/>
				<InputControl 
					label={t('user.email')}
					name="email" 
					type="email" 
					value={this.state.user?.email || ''} 
					onChange={e => this.updateUserProperty(this, 'email', e.target.value)} 
					max="255" 
					required 
					error={this.props.errors?.email || ''}
				/>
				<TextareaControl 
					label={t('user.description')}
					name="description" 
					value={this.state.user?.description || ''} 
					onChange={e => this.updateUserProperty(this, 'description', e.target.value)} 
					rows="5" 
					error={this.props.errors?.description || ''}
				/>

				<div className="mb-3">
				  <label htmlFor="as" className="form-label">{t('user.job')}</label>
				  <select 
				  	className="form-select" 
				  	name="job" 
				  	value={this.state.user?.job} 
				  	onChange={e => this.updateUserProperty(this, 'job', e.target.value)}
				  >
					  <option value="tester">Tester</option>
					  <option value="developer">Developer</option>
					  <option value="project_manager">Project manager</option>
				  </select>
				</div>

				{this.state.user?.job && this.state.user.job === 'tester' && (
					<div>
						<InputControl 
							label={t('user.testingSystems')}
							name="testingSystems" 
							value={this.state.user?.testingSystems || ''} 
							onChange={e => this.updateUserProperty(this, 'testingSystems', e.target.value)} 
							max="255" 
							required 
							error={this.props.errors?.testingSystems || ''}
						/>
						<InputControl 
							label={t('user.reportSystems')}
							name="reportSystems" 
							value={this.state.user?.reportSystems || ''} 
							onChange={e => this.updateUserProperty(this, 'reportSystems', e.target.value)} 
							max="255" 
							required 
							error={this.props.errors?.reportSystems || ''}
						/>
						<CheckboxControl 
							label={t('user.knowsSelenium')}
							name="knowsSelenium" 
							value={this.state.user?.knowsSelenium || false} 
							onChange={e => this.updateUserProperty(this, 'knowsSelenium', e.target.value)} 
						/>
					</div>
				)}

				{this.state.user?.job && this.state.user.job === 'developer' && (
					<div>
						<InputControl 
							label={t('user.ideEnvironments')}
							name="ideEnvironments" 
							value={this.state.user?.ideEnvironments || ''} 
							onChange={e => this.updateUserProperty(this, 'ideEnvironments', e.target.value)} 
							max="255" 
							required 
							error={this.props.errors?.ideEnvironments || ''}
						/>
						<InputControl 
							label={t('user.programmingLanguages')}
							name="programmingLanguages" 
							value={this.state.user?.programmingLanguages || ''} 
							onChange={e => this.updateUserProperty(this, 'programmingLanguages', e.target.value)} 
							max="255"
							required 
							error={this.props.errors?.programmingLanguages || ''}
						/>
						<CheckboxControl 
							label={t('user.knowsMySQL')}
							name="knowsMySQL" 
							value={this.state.user?.knowsMySQL || false} 
							onChange={e => this.updateUserProperty(this, 'knowsMySQL', e.target.value)} 
						/>
					</div>
				)}

				{this.state.user?.job && this.state.user.job === 'project_manager' && (
					<div>
						<InputControl 
							label={t('user.projectManagementMethodologies')}
							name="projectManagementMethodologies" 
							value={this.state.user?.projectManagementMethodologies || ''} 
							onChange={e => this.updateUserProperty(this, 'projectManagementMethodologies', e.target.value)} 
							max="255" 
							required 
							error={this.props.errors?.projectManagementMethodologies || ''}
						/>
						<InputControl 
							label={t('user.reportSystems')}
							name="reportSystems" 
							value={this.state.user?.reportSystems || ''} 
							onChange={e => this.updateUserProperty(this, 'reportSystems', e.target.value)} 
							max="255" 
							required 
							error={this.props.errors?.reportSystems || ''}
						/>
						<CheckboxControl 
							label={t('user.knowsScrum')}
							name="knowsScrum" 
							value={this.state.user?.knowsScrum || false} 
							onChange={e => this.updateUserProperty(this, 'knowsScrum', e.target.value)} 
						/>
					</div>
				)}

				<Button text={t('general.submit')} type="submit" classes="btn-success" />
			</form>
		);
	}
}