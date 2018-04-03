import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import { fetchMunicipality } from "../actions/municipalities";
import { connect } from 'react-redux';
import {Card, CardActions, CardHeader, CardMedia, CardTitle, CardText} from 'material-ui/Card';
import {
    Table,
    TableBody,
    TableHeader,
    TableHeaderColumn,
    TableRow,
    TableRowColumn,
} from 'material-ui/Table';
import FlatButton from 'material-ui/FlatButton';

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
                 <Card>
                    <CardText>
                        <h1>{municipality.name}</h1>
                        <p><strong>ISTAT Code:</strong> {municipality.istatCode}</p>
                        <p><strong>Province:</strong> {municipality.province.name} ({municipality.province.code})</p>
                        <p><strong>Number:</strong> {municipality.number}</p>
                        <p><strong>Geographical Division:</strong> {municipality.geographicalDivision.name}</p>
                        <p><strong>Cadastral Code:</strong> {municipality.cadastralCode}</p>
                        <p><strong>Is Provincial Capital:</strong> {municipality.isProvincialCapital ? 'Yes' : 'No'}</p>
                        <p><strong>License Plate Code:</strong> {municipality.licensePlateCode}</p>
                    </CardText>
                    <CardActions>
                        <FlatButton label="Back to List" containerElement={<Link to="/"/>}/>
                        <FlatButton label="Edit" containerElement={<Link to="/"/>}/>
                        <FlatButton label="Delete" containerElement={<Link to="/"/>}/>
                    </CardActions>
                </Card>
            </div>
        );
    }
}

function mapStateToProps({ municipalities }, ownProps) {
    const municipality = municipalities[ownProps.match.params.id];
    return { municipality };
}

export default connect(mapStateToProps, { fetchMunicipality })(MunicipalityShow);