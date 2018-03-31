import { combineReducers } from 'redux';
import MunicipalitiesReducer from './municipalities';

const rootReducer = combineReducers({
    municipalities: MunicipalitiesReducer
});

export default rootReducer;
