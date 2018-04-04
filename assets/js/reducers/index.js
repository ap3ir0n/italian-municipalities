import { combineReducers } from 'redux';
import municipalitiesReducer from './municipalities';
import provincesReducer from './provinces';
import geographicalDivisionsReducer from './geographicalDivisions';
import { reducer as reduxFormReducer } from 'redux-form';

const rootReducer = combineReducers({
    municipalities: municipalitiesReducer,
    provinces: provincesReducer,
    geographicalDivisions: geographicalDivisionsReducer,
    form: reduxFormReducer
});

export default rootReducer;
