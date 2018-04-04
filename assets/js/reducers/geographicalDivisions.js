import _ from 'lodash';
import { FETCH_GEOGRAPHICAL_DIVISIONS } from '../actions/geographicalDivisions';

export default function (state = {}, action) {
    switch (action.type) {
        case FETCH_GEOGRAPHICAL_DIVISIONS:
            return _.mapKeys(action.payload.data._embedded.items, 'id');
        default:
            return state;
    }
}
