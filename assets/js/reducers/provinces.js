import _ from 'lodash';
import { FETCH_PROVINCES } from '../actions/provinces';

export default function (state = {}, action) {
    switch (action.type) {
        case FETCH_PROVINCES:
            return _.mapKeys(action.payload.data._embedded.items, 'id');
        default:
            return state;
    }

}
