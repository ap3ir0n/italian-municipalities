import React, { Component } from 'react';
import { Field, reduxForm } from 'redux-form';
import { Link } from 'react-router-dom';
import { connect } from 'react-redux';
import { editMunicipality, fetchMunicipality } from '../actions/municipalities';
import { fetchProvinces } from '../actions/provinces';
import { fetchGeographicalDivisions } from '../actions/geographicalDivisions';
import TextField from 'material-ui/TextField';
import RaisedButton from 'material-ui/RaisedButton';
import SelectField from 'material-ui/SelectField';
import MenuItem from 'material-ui/MenuItem';
import Checkbox from 'material-ui/Checkbox';

const loadMunicipality = () => {
    return fetchMunicipality(2);
};

const style = {
    margin: 12,
};

class InitializeFromStateForm extends React.Component  {
    constructor(props) {
        super(props)
    }

    componentDidMount() {
        this.props.loadMunicipality();
        this.props.fetchProvinces();
        this.props.fetchGeographicalDivisions();
    }

    render() {
        const { handleSubmit, loadMunicipality, pristine, reset, submitting } = this.props;
        return (
            <form onSubmit={handleSubmit}>
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
                            label="License PlateCode"
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
                    <RaisedButton label="Cancel" style={style}/>
                    <RaisedButton label="Submit" style={style} primary={true}/>
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

InitializeFromStateForm = reduxForm({
    form: 'initializeFromState',
})(InitializeFromStateForm);

const mapStateToProps = (state)  => {
    const municipality = state.municipalities[2];
    let initialValues = state.initialValues;
    if (initialValues == undefined && municipality != undefined) {
        initialValues = _.mapValues(municipality, value => {
            if (_.isObject(value)) {
                return value.id;
            }
            return value;
        });
    }
    return {
        initialValues,
        provinces: state.provinces,
        geographicalDivisions: state.geographicalDivisions
    }
};

InitializeFromStateForm = connect(
    mapStateToProps, { loadMunicipality, fetchProvinces, fetchGeographicalDivisions },
)(InitializeFromStateForm);

export default InitializeFromStateForm;