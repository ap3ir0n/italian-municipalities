import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';
import { fetchMunicipalities } from '../actions/municipalities'

class MunicipalitiesIndex extends Component {

    componentDidMount() {
        this.props.fetchMunicipalities();
    }

    render() {
        return(
            <div>
                <h1>Municipalities List</h1>
                <ul>
                {this.renderMunicipalities()}
                </ul>
            </div>
        )
    }

    renderMunicipalities() {
        return _.map(this.props.municipalities, municipality => {
            return (
                <li key={municipality.id}>
                    <Link to={`/municipalities/${municipality.id}`}>{municipality.name}</Link>
                </li>
            );
        });
    }
}

function mapStateToProps(state) {
    return  { municipalities: state.municipalities }
}

export default connect(mapStateToProps, { fetchMunicipalities })(MunicipalitiesIndex);