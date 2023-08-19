/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import React from 'react';
import ReactDom from 'react-dom';
import App from './scripts/components/app.jsx';
import 'bootstrap';
import axios from 'axios';
import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

i18n
  .use(initReactI18next)
  .init({
    resources: {
      pl: {
      	translation: require('./locales/pl.json'),
      }
    },
    lng: 'pl',
    fallbackLng: 'pl',
    interpolation: {
      escapeValue: false,
    }
  });

const root = ReactDom.createRoot(document.getElementById('app'));

root.render(App());