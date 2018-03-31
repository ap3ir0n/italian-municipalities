import React from 'react';
import ReactDOM from 'react-dom';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import MunicipalitiesIndex from './components/MunicipalitiesIndex';
import MunicipalityShow from './components/MunicipalityShow';
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
                                <Route path="/municipalities/:id" component={MunicipalityShow}/>
                                <Route path="/" component={MunicipalitiesIndex}/>
                            </Switch>
                        </BrowserRouter>
                    </div>
                </MuiThemeProvider>
            </Provider>
        );
    }
}

ReactDOM.render(<App/>, document.getElementById('root'));