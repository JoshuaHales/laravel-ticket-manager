import React, { useState, useEffect } from 'react';

import axios from 'axios';
import TicketsTable from '@/Components/TicketsTable';
import { useLocation, useNavigate } from 'react-router-dom';

/**
 * TicketsList Component
 *
 * Displays a paginated list of tickets and allows filtering by status (open/closed).
 * The component fetches tickets from the server, supports pagination, and updates in real-time.
 *
 * @returns {JSX.Element} The rendered tickets list component.
 */
const TicketsList = () => {
    const navigate = useNavigate();
    const location = useLocation();

    const [tickets, setTickets] = useState([]);
    const [status, setStatus] = useState('open');
    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);
    const [loading, setLoading] = useState(true); // Loading state to show while data is being fetched

    /**
     * Helper function to get query parameters from the URL
     * 
     * @param {string} param - The name of the query parameter to retrieve.
     * @returns {string|null} - The value of the query parameter.
     */
    const getQueryParam = (param) => {
        const urlParams = new URLSearchParams(location.search);
        return urlParams.get(param);
    };

    /**
     * Fetches tickets from the server based on status and page number.
     * 
     * @param {number} [page=1] - The page number to fetch.
     * @param {string} [statusParam=status] - The ticket status (open/closed) to filter by.
     */
    const fetchTickets = async (page = 1, statusParam = status) => {
        setLoading(true); // Set loading to true when fetching data
        try {
            const response = await axios.get(`/api/tickets/${statusParam}?page=${page}`);

            setTickets(response.data.data);
            setTotalPages(response.data.meta.last_page);
            setCurrentPage(response.data.meta.current_page);
        } catch (error) {
            console.error('Error fetching tickets:', error);
        } finally {
            setLoading(false); // Stop loading once data is fetched or on error
        }
    };

    /**
     * Handles status changes (open or closed) and fetches the corresponding tickets.
     * 
     * @param {string} newStatus - The new status (open or closed) to filter tickets by.
     */
    const handleStatusChange = (newStatus) => {
        setStatus(newStatus);
        navigate(`/tickets?status=${newStatus}&page=1`, { replace: true });
        fetchTickets(1, newStatus);
    };

    /**
     * Handles pagination changes and fetches the corresponding tickets.
     * 
     * @param {number} newPage - The new page number to navigate to and fetch tickets for.
     */
    const handlePageChange = (newPage) => {
        setCurrentPage(newPage);
        navigate(`/tickets?status=${status}&page=${newPage}`, { replace: true });
        fetchTickets(newPage, status);
    };

    // Fetch tickets on initial load and when status or page changes
    useEffect(() => {
        const statusParam = getQueryParam('status') || 'open';
        const pageParam = getQueryParam('page') || 1;

        setStatus(statusParam);
        fetchTickets(pageParam, statusParam);
    }, [location]);

    // Set up real-time updates for new tickets
    useEffect(() => {
        const channel = window.Echo.channel('tickets')
            .listen('TicketUpdated', () => {
                fetchTickets(currentPage, status); // Re-fetch tickets when a new one is created
            });

        return () => {
            channel.stopListening('TicketUpdated');
        };
    }, [currentPage, status]);

    return (
        <div className="container mx-auto p-4">
            <div className="flex justify-between items-center mb-4">
                <h2 className="text-xl font-bold">
                    {status === 'open' ? 'Open Tickets' : 'Closed Tickets'}
                </h2>
                <div>
                    <button
                        className={`mx-2 px-4 py-2 border rounded ${status === 'open' ? 'bg-blue-500 text-white' : 'bg-gray-200'}`}
                        onClick={() => handleStatusChange('open')}
                        disabled={loading} // Disable buttons while loading
                    >
                        Open Tickets
                    </button>
                    <button
                        className={`mx-2 px-4 py-2 border rounded ${status === 'closed' ? 'bg-blue-500 text-white' : 'bg-gray-200'}`}
                        onClick={() => handleStatusChange('closed')}
                        disabled={loading} // Disable buttons while loading
                    >
                        Closed Tickets
                    </button>
                </div>
            </div>

            <TicketsTable tickets={tickets} />

            {/* Pagination */}
            <div className="flex justify-center mt-4">
                {Array.from({ length: totalPages }, (_, index) => (
                    <button
                        key={index}
                        onClick={() => handlePageChange(index + 1)}
                        className={`mx-1 px-3 py-1 border rounded ${currentPage === index + 1 ? 'bg-blue-500 text-white' : 'bg-gray-200'}`}
                        disabled={loading} // Disable pagination buttons while loading
                    >
                        {index + 1}
                    </button>
                ))}
            </div>
        </div>
    );
};

export default TicketsList;