import _ from 'lodash';
import { FETCH_MUNICIPALITIES, FETCH_MUNICIPALITY } from '../actions/municipalities';

export default function (state = {}, action) {
    switch (action.type) {
        case FETCH_MUNICIPALITIES:
            return _.mapKeys(action.payload.data._embedded.items, 'id');
        case FETCH_MUNICIPALITY:
            const municipality = action.payload.data;
            return { ...state, [municipality.id]: municipality}
        default:
            return state;
    }

}
