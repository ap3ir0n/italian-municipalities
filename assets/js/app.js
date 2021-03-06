import React from 'react';
import ReactDOM from 'react-dom';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import MunicipalitiesIndex from './components/MunicipalitiesIndex';
import MunicipalityShow from './components/MunicipalityShow';
import MunicipalityEdit from './components/MunicipalityEdit';
import { createStore, applyMiddleware } from 'redux';
import { Provider } from 'react-redux';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import promise from 'redux-promise';
import AppBar from 'material-ui/AppBar';

import reducers from './reducers';

const createStoreWithMiddleware = applyMiddleware(promise)(createStore);

class App extends React.Component {
    render() {
        return (
            <Provider store={createStoreWithMiddleware(reducers)}>
                <MuiThemeProvider>
                    <div>
                        <AppBar
                            title="Italian Municipalities"
                            showMenuIconButton={false}
                            iconClassNameRight="muidocs-icon-navigation-expand-more"
                        />
                        <BrowserRouter>
                            <Switch>
                                <Route path="/municipalities/:id/edit" component={MunicipalityEdit}/>
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