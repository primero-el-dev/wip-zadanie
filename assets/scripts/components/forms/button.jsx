import React from 'react';

export default function({ text: text, type: type, classes: classes }) {
	return (
		<button type={type || "button"} className={"btn btn-block w-100 " + classes}>{text}</button>
	);
}