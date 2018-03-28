import React from 'react';
import ReactDOM from 'react-dom';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';

class App extends React.Component {
    constructor() {
        super();

        this.state = {
            entries: []
        };
    }

    render() {
        return (
            <MuiThemeProvider>
                <div style={{display: 'flex'}}>
                    Test
                </div>
            </MuiThemeProvider>
        );
    }
}

ReactDOM.render(<App/>, document.getElementById('root'));