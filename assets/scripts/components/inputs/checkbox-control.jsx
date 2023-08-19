import React from 'react';
import { v4 as uuidv4 } from 'uuid';

export default function({ label, classes, error, ...props }) {
	const id = props.id || uuidv4();
	
	return (
		<div className="mb-3">
		  <input type="checkbox" className={'form-check-input ' + classes} id={id} checked={props.value ? 'checked' : ''} {...props} />
		  <label htmlFor={id} className="form-check-check ms-2">{label}</label>
		  <small className="text-danger">{error}</small>
		</div>
	);
}