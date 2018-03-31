import React from 'react';
import ReactDOM from 'react-dom';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import MinicipalitiesIndex from './components/MunicipalitiesIndex';
import { createStore, applyMiddleware } from 'redux';
import { Provider } from 'react-redux';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import promise from 'redux-promise';

import reducers from './reducers';

const createStoreWithMiddleware = applyMiddleware(promise)(createStore);

class App extends React.Component {
    render() {
        return (
            <Provider store={createStoreWithMiddleware(reducers)}>
                <MuiThemeProvider>
                    <div style={{display: 'flex'}}>
                        <BrowserRouter>
                            <Switch>
                                <Route path="/" component={MinicipalitiesIndex}/>
                            </Switch>
                        </BrowserRouter>
                    </div>
                </MuiThemeProvider>
            </Provider>
        );
    }
}

ReactDOM.render(<App/>, document.getElementById('root'));