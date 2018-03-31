import _ from 'lodash';
import { FETCH_MUNICIPALITIES } from '../actions/municipalities';

export default function (state = {}, action) {
    switch (action.type) {
        case FETCH_MUNICIPALITIES:
            return _.mapKeys(action.payload.data._embedded.items, 'id');
        default:
            return state;
    }

}
