import React, { Component } from 'react';
import { Field, reduxForm } from 'redux-form';
import { Link } from 'react-router-dom';
import { connect, submit } from 'react-redux';
import { editMunicipality, fetchMunicipality } from '../actions/municipalities';
import { fetchProvinces } from '../actions/provinces';
import { fetchGeographicalDivisions } from '../actions/geographicalDivisions';
import TextField from 'material-ui/TextField';
import RaisedButton from 'material-ui/RaisedButton';
import SelectField from 'material-ui/SelectField';
import MenuItem from 'material-ui/MenuItem';
import Checkbox from 'material-ui/Checkbox';

const style = {
    margin: 12,
};

class MunicipalityEdit extends React.Component  {
    constructor(props) {
        super(props)
    }

    componentDidMount() {
        const { id } = this.props.match.params;
        this.props.fetchMunicipality(id);
        this.props.fetchProvinces();
        this.props.fetchGeographicalDivisions();
    }

    onSubmit(values) {
        const { id } = this.props.match.params;
        this.props.editMunicipality(id, values, () => {
            this.props.history.push(`/municipalities/${id}`);
        });
    }

    render() {
        const { handleSubmit, municipality } = this.props;
        const cancelLink = '/municipalities' + (municipality !== undefined ? `/${municipality.id}` : '');
        return (
            <form onSubmit={handleSubmit(this.onSubmit.bind(this))}>
                <div>
                    <div>
                        <Field
                            name="name"
                            label="Name"
                            component={this.renderTextField}
                        />
                    </div>
                    <div>
                        <Field
                            name="geographicalDivision"
                            label="Geographical Division"
                            component={this.renderSelectField}
                        >
                            {this.renderGeographicalDivisions()}
                        </Field>
                    </div>
                    <div>
                        <Field
                            name="province"
                            label="Province"
                            component={this.renderSelectField}
                        >
                            {this.renderProvinces()}
                        </Field>
                    </div>
                    <div>
                        <Field
                            name="isProvincialCapital"
                            label="Provincial Capital"
                            component={this.renderCheckbox}
                        />
                    </div>
                    <div>
                        <Field
                            name="licensePlateCode"
                            label="License Plate Code"
                            component={this.renderTextField}
                        />
                    </div>
                    <div>
                        <Field
                            name="number"
                            label="Number"
                            component={this.renderTextField}
                        />
                    </div>
                    <div>
                        <Field
                            name="istatCode"
                            label="Istat Code"
                            component={this.renderTextField}
                        />
                    </div>
                </div>
                <div>
                    <RaisedButton label="Cancel" style={style} containerElement={<Link to={cancelLink}/>}/>
                    <RaisedButton type="submit" label="Submit" style={style} primary={true}/>
                </div>
            </form>
        );
    }

    renderProvinces() {
        return _.map(this.props.provinces, province => {
            return <MenuItem key={province.id} value={province.id} primaryText={province.name}/>
        });
    }

    renderGeographicalDivisions() {
        return _.map(this.props.geographicalDivisions, province => {
            return <MenuItem key={province.id} value={province.id} primaryText={province.name}/>
        });
    }

    renderTextField({
        input,
        label,
        meta: { touched, error },
        ...custom
    }) {
        return(
            <TextField
                hintText={label}
                floatingLabelText={label}
                errorText={touched && error}
                {...input}
                {...custom}
            />
        )
    }

    renderSelectField({
        input,
        label,
        meta: { touched, error },
        children,
        ...custom
    }) {
        return(
            <SelectField
                floatingLabelText={label}
                errorText={touched && error}
                {...input}
                onChange={(event, index, value) => input.onChange(value)}
                children={children}
                {...custom}
            />
        )
    }

    renderCheckbox({ input, label }) {
        return (
            <Checkbox
                label={label}
                checked={input.value ? true : false}
                onCheck={input.onChange}
            />
        )
    }

}

MunicipalityEdit = reduxForm({
    form: 'initializeFromState',
})(MunicipalityEdit);

const mapStateToProps = (state, ownProps)  => {
    const municipality = state.municipalities[ownProps.match.params.id];
    let initialValues = state.initialValues;
    if (initialValues === undefined && municipality !== undefined) {
        initialValues = _.mapValues(municipality, value => {
            if (_.isObject(value)) {
                return value.id;
            }
            return value;
        });
    }
    return {
        municipality,
        initialValues,
        provinces: state.provinces,
        geographicalDivisions: state.geographicalDivisions
    }
};

MunicipalityEdit = connect(
    mapStateToProps, { editMunicipality, fetchMunicipality, fetchProvinces, fetchGeographicalDivisions },
)(MunicipalityEdit);

export default MunicipalityEdit;