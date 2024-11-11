// assets/react/controllers/Hello.jsx
import React from 'react';

/*export default function (props) {
    return <div>Hello {props.fullName}</div>;
}*/
import {createRoot} from 'react-dom/client';

// Exemple de composant React simple
const root = createRoot(document.getElementById('root'));
root.render(<h1>Bonjour, Cinephoria!</h1>);
