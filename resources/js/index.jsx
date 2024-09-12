// resources/js/app.jsx

import './bootstrap';
import App from './App';
import React from 'react';
import { createRoot } from 'react-dom/client';

const root = createRoot(document.getElementById('app'));
root.render(<App />);