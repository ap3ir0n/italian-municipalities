import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import RaisedButton from 'material-ui/RaisedButton';
import FlatButton from 'material-ui/FlatButton';
import {
    Table,
    TableBody,
    TableHeader,
    TableHeaderColumn,
    TableRow,
    TableRowColumn,
    TableFooter
} from 'material-ui/Table';
import {Toolbar, ToolbarGroup, ToolbarSeparator, ToolbarTitle} from 'material-ui/Toolbar';
import { fetchMunicipalities } from "../actions/municipalities";
import { connect } from "react-redux";

class MunicipalitiesIndex extends Component {

    componentDidMount() {
        this.props.fetchMunicipalities();
    }

    render() {
        return(
            <div>
                <Table selectable={false} onCellClick={this.showMunicipality}>
                    <TableHeader displaySelectAll={false} adjustForCheckbox={false}>
                        <TableRow>
                            <TableHeaderColumn>Name</TableHeaderColumn>
                            <TableHeaderColumn>Province</TableHeaderColumn>
                            <TableHeaderColumn>Geographical Division</TableHeaderColumn>
                            <TableHeaderColumn>Number</TableHeaderColumn>
                            <TableHeaderColumn>Cadastral Code</TableHeaderColumn>
                            <TableHeaderColumn>Actions</TableHeaderColumn>
                        </TableRow>
                    </TableHeader>
                    <TableBody displayRowCheckbox={false} showRowHover={true}>
                        {this.renderMunicipalities()}
                    </TableBody>
                </Table>
                <Toolbar>
                    <ToolbarGroup firstChild={true}>
                        <FlatButton label="<<" containerElement={<Link to="/"/>}/>
                        <FlatButton label="<" containerElement={<Link to="/"/>}/>
                        <span>Pag. 1</span>
                        <FlatButton label=">" containerElement={<Link to="/"/>}/>
                        <FlatButton label=">>" containerElement={<Link to="/"/>}/>
                    </ToolbarGroup>
                </Toolbar>
            </div>
        )
    }

    renderMunicipalities() {
        return _.map(this.props.municipalities, municipality => {
            return (
                <TableRow key={municipality.id}>
                    <TableRowColumn>{municipality.name}</TableRowColumn>
                    <TableRowColumn>{municipality.province.name}</TableRowColumn>
                    <TableRowColumn>{municipality.geographicalDivision.name}</TableRowColumn>
                    <TableRowColumn>{municipality.number}</TableRowColumn>
                    <TableRowColumn>{municipality.cadastralCode}</TableRowColumn>
                    <TableHeaderColumn><RaisedButton label="View" containerElement={<Link to={`/municipalities/${municipality.id}`}>Home</Link>}/></TableHeaderColumn>
                </TableRow>
            );
        });
    }

    showMunicipality(row, column) {
        console.log('Show municipality', row, column);
    }
}

function mapStateToProps(state) {
    return  {
        municipalities: state.municipalities
    }
}

export default connect(mapStateToProps, { fetchMunicipalities })(MunicipalitiesIndex);