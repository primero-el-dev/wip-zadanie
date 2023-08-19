import React from 'react';
import { v4 as uuidv4 } from 'uuid';

export default function({ label: label, classes: classes, error: error, ...props }) {
	const id = props.id || uuidv4();
	
	return (
		<div className="mb-3">
		  <label htmlFor={id} className="form-label">{label}</label>
		  <input className={'form-control ' + classes} id={id} {...props} />
		  <small className="text-danger">{error}</small>
		</div>
	);
}