import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import App from './App';
import {RecoilRoot} from "recoil";
import {HashRouter} from "react-router-dom";

ReactDOM.render(
  <React.StrictMode>
      <RecoilRoot>
          <HashRouter>
            <App />
          </HashRouter>
      </RecoilRoot>
  </React.StrictMode>,
  document.getElementById('root')
);
