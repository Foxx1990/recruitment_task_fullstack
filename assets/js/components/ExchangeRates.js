import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useHistory, useParams } from 'react-router-dom';

const ExchangeRates = () => {
    // State to store exchange rates data
    const [rates, setRates] = useState([]);
    const [selectedDate, setSelectedDate] = useState(new Date().toISOString().split('T')[0]);
    // Extract date from URL parameters
    const { date } = useParams();
    // History object to programmatically navigate
    const history = useHistory();

 // Fetch rates when the component mounts or the date changes
    useEffect(() => {
        if (date) {
            setSelectedDate(date);
        }
        fetchRates(selectedDate);
    }, [date, selectedDate]);
 // Function to fetch exchange rates from the backend API
    const fetchRates = async (date) => {
        try {
            const response = await axios.get(`/api/exchange-rates/${date}`);
            setRates(response.data);
        } catch (error) {
            console.error('Error fetching exchange rates', error);
        }
    };
// Handle date change and update the URL
    const handleDateChange = (e) => {
        const newDate = e.target.value;
        history.push(`/exchange-rates/${newDate}`);
        fetchRates(newDate);
    };

    return (
        <div className="container">
            <h1>Notowania walut według NBP dla daty: {selectedDate}</h1>
            <div className="form-group">
                <label htmlFor="date">Wybierz datę:</label>
                <input
                    type="date"
                    id="date"
                    value={selectedDate}
                    onChange={handleDateChange}
                />
            </div>
            <table className="table">
                <thead>
                    <tr>
                        <th>Waluta</th>
                        <th>Nazwa waluty</th>
                        <th>Średnia stawka (NBP)</th>
                        <th>Kupno waluty</th>
                        <th>Sprzedaż waluty</th>
                    </tr>
                </thead>
                <tbody>
                    {rates.map((rate) => (
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
};

export default ExchangeRates;