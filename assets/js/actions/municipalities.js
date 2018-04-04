import axios from 'axios';
import _ from 'lodash';

const ROOT_URL = '/api/';

export const FETCH_MUNICIPALITIES = 'FETCH_MUNICIPALITIES';
export const FETCH_MUNICIPALITY = 'FETCH_MUNICIPALITY';
export const EDIT_MUNICIPALITY = 'EDIT_MUNICIPALITY';

export function fetchMunicipalities(url = null) {
    if (!url) {
        url = `${ROOT_URL}municipalities`;
    }
    const request = axios.get(url);

    return {
        type: FETCH_MUNICIPALITIES,
        payload: request
    };
}

export function fetchMunicipality(id) {
    const request = axios.get(`${ROOT_URL}municipalities/${id}`);

    return {
        type: FETCH_MUNICIPALITY,
        payload: request
    };
}

export function editMunicipality(id, values, callback) {
    const bodyFormData = new FormData();
    _.forIn(values, (value, key) => {
        bodyFormData.set(key, value);
    });

    const request = axios({
        method: 'post',
        url: `${ROOT_URL}municipalities/${id}`,
        data: bodyFormData,
        config: { headers: {'Content-Type': 'multipart/form-data' }}
    }).then(() => callback());

    return {
        type: EDIT_MUNICIPALITY,
        payload: request
    };
}