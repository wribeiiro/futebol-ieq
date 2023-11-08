import React from "react";
import App from './App';
import ReactDOM from 'react-dom/client';
import reportWebVitals from './reportWebVitals';
import PWAPrompt from 'react-ios-pwa-prompt';
import * as serviceWorkerRegistration from './serviceWorkerRegistration';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'popper.js';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import './i18n.js'

const root = ReactDOM.createRoot(document.getElementById('root'));

root.render(
	<React.StrictMode>
		<App />
		<PWAPrompt
			promptOnVisit={1}
			timesToShow={3}
			copyClosePrompt="Close"
			permanentlyHideOnDismiss={false}
		/>
	</React.StrictMode>
);

serviceWorkerRegistration.register();
reportWebVitals();
