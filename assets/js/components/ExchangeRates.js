import React, { Component } from 'react';
import axios from 'axios';
import { withRouter } from 'react-router-dom';

class ExchangeRates extends Component {
    constructor(props) {
        super(props);
        const today = new Date().toISOString().split('T')[0];
        const { date } = this.props.match.params;
        this.state = {
            rates: [],
            selectedDate: date || today,
        };
    }

    componentDidMount() {
        this.fetchRates(this.state.selectedDate);
    }

    componentDidUpdate(prevProps, prevState) {
        const { date } = this.props.match.params;
        if (date !== prevProps.match.params.date) {
            this.setState({ selectedDate: date }, () => {
                this.fetchRates(this.state.selectedDate);
            });
        }
    }

    fetchRates = async (date) => {
        try {
            const response = await axios.get(`/api/exchange-rates/${date}`);
            this.setState({ rates: response.data });
        } catch (error) {
            console.error('Error fetching exchange rates', error);
        }
    };

    handleDateChange = (e) => {
        const newDate = e.target.value;
        this.props.history.push(`/exchange-rates/${newDate}`);
    };

    render() {
        return (
            <div className="container">
                <h1>Exchange Rates for {this.state.selectedDate}</h1>
                <div className="form-group">
                    <label htmlFor="date">Select Date:</label>
                    <input
                        type="date"
                        id="date"
                        value={this.state.selectedDate}
                        onChange={this.handleDateChange}
                    />
                </div>
                <table className="table">
                    <thead>
                        <tr>
                            <th>Currency</th>
                            <th>Name</th>
                            <th>Mid Rate (NBP)</th>
                            <th>Buy Rate</th>
                            <th>Sell Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        {this.state.rates.map((rate) => (
                            <tr key={rate.currency}>
                                <td>{rate.currency}</td>
                                <td>{rate.name}</td>
                                <td>{rate.mid}</td>
                                <td>{rate.buy || 'N/A'}</td>
                                <td>{rate.sell}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        );
    }
}

export default withRouter(ExchangeRates);