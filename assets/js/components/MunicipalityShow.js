import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import { fetchMunicipality } from "../actions/municipalities";
import { connect } from 'react-redux'

class MunicipalityShow extends Component {

    componentDidMount() {
        const { id } = this.props.match.params;
        this.props.fetchMunicipality(id);
    }

    render() {
        const { municipality } = this.props;

        if (!municipality) {
            return <div>Loading...</div>;
        }

        return(
            <div>
                <Link to="/">Back to Index</Link>
                <h1>{municipality.name}</h1>
                <p><strong>Province:</strong> {municipality.province.name}</p>
                <p><strong>Geographical Division:</strong>: {municipality.geographicalDivision.name}</p>
            </div>
        );
    }
}

function mapStateToProps({ municipalities }, ownProps) {
    const municipality = municipalities[ownProps.match.params.id];
    return { municipality };
}

export default connect(mapStateToProps, { fetchMunicipality })(MunicipalityShow);