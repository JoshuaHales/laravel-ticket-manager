import React from 'react';

import TicketsList from './Pages/TicketsList';
import UserTickets from './Pages/UserTickets';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';

function App() {
    return (
        <Router>
            <Routes>
                <Route path="/tickets" element={<TicketsList />} />
                <Route path="/users/:userId/tickets" element={<UserTickets />} />
                <Route path="/" element={<TicketsList />} /> {/* Default route */}
            </Routes>
        </Router>
    );
}

export default App;