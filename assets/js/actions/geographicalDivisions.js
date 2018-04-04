import axios from 'axios';

const ROOT_URL = '/api/';

export const FETCH_GEOGRAPHICAL_DIVISIONS = 'FETCH_GEOGRAPHICAL_DIVISIONS';

export function fetchGeographicalDivisions(url = null) {
    if (!url) {
        url = `${ROOT_URL}geographical-divisions`;
    }
    const request = axios.get(url);

    return {
        type: FETCH_GEOGRAPHICAL_DIVISIONS,
        payload: request
    };
}
