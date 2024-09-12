import React from 'react';

import { Link } from 'react-router-dom';

/**
 * TicketsTable Component
 *
 * Displays a table of tickets with subject, content, user, and status.
 *
 * @param {Array} tickets - Array of ticket objects to be displayed in the table.
 * @returns {JSX.Element} The rendered tickets table.
 */
const TicketsTable = ({ tickets = [] }) => {
    // Check if the tickets array is valid and has entries
    const hasTickets = tickets && tickets.length > 0;

    return (
        <div className="overflow-x-auto">
            <table className="min-w-full bg-white border border-gray-300 rounded-md shadow-md">
                <thead>
                    <tr className="bg-gray-200 text-gray-700">
                        <th className="py-2 px-4 border-b">Subject</th>
                        <th className="py-2 px-4 border-b">Content</th>
                        <th className="py-2 px-4 border-b">User</th>
                        <th className="py-2 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {hasTickets ? (
                        tickets.map((ticket) => (
                            <tr key={ticket.id} className="hover:bg-gray-100">
                                <td className="py-2 px-4 border-b">{ticket.subject}</td>
                                <td className="py-2 px-4 border-b">{ticket.content}</td>
                                <td className="py-2 px-4 border-b">
                                    {ticket.user ? (
                                        <Link
                                            to={`/users/${ticket.user.id}/tickets`}
                                            className="text-blue-500 hover:underline"
                                        >
                                            {ticket.user.name}
                                        </Link>
                                    ) : (
                                        <span className="text-red-500">Unknown User</span>
                                    )}
                                </td>
                                <td className="py-2 px-4 border-b">
                                    <span
                                        className={`px-2 py-1 rounded ${ticket.status ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`}
                                    >
                                        {ticket.status ? 'Closed' : 'Open'}
                                    </span>
                                </td>
                            </tr>
                        ))
                    ) : (
                        // Display a message when there are no tickets available
                        <tr>
                            <td colSpan="4" className="text-center py-4">
                                No tickets available.
                            </td>
                        </tr>
                    )}
                </tbody>
            </table>
        </div>
    );
};

export default TicketsTable;