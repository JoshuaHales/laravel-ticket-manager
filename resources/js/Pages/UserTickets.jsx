import React, { useState, useEffect } from 'react';

import axios from 'axios';
import TicketsTable from '@/Components/TicketsTable';
import { Link, useParams, useLocation, useNavigate } from 'react-router-dom';

/**
 * UserTickets Component
 *
 * Displays a list of tickets for a specific user, with pagination and real-time updates.
 * Tickets are fetched based on the userId passed from the URL.
 *
 * @returns {JSX.Element} The rendered UserTickets component.
 */
const UserTickets = () => {
    const { userId } = useParams(); // Get userId from the URL
    const navigate = useNavigate();
    const location = useLocation();

    const [tickets, setTickets] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);
    const [loading, setLoading] = useState(true); // Loading state for better UX

    /**
     * Helper function to get query parameters from the URL.
     *
     * @param {string} param - The name of the query parameter to retrieve.
     * @returns {string|null} - The value of the query parameter.
     */
    const getQueryParam = (param) => {
        const urlParams = new URLSearchParams(location.search);
        return urlParams.get(param);
    };

    /**
     * Fetches user tickets based on userId and the current page.
     *
     * @param {number} [page=1] - The page number to fetch.
     */
    const fetchUserTickets = async (page = 1) => {
        setLoading(true); // Set loading state when fetching data
        try {
            const response = await axios.get(`/api/users/${userId}/tickets?page=${page}`);

            setTickets(response.data.data);
            setTotalPages(response.data.meta.last_page);
            setCurrentPage(response.data.meta.current_page);
        } catch (error) {
            console.error('Error fetching user tickets:', error);
        } finally {
            setLoading(false); // Stop loading after data is fetched or in case of error
        }
    };

    /**
     * Handles page changes for pagination.
     *
     * @param {number} newPage - The new page number to navigate to and fetch tickets for.
     */
    const handlePageChange = (newPage) => {
        setCurrentPage(newPage);
        navigate(`/users/${userId}/tickets?page=${newPage}`, { replace: true });
        fetchUserTickets(newPage);
    };

    // Fetch tickets on initial load and when the page or userId changes
    useEffect(() => {
        const pageParam = getQueryParam('page') || 1;
        fetchUserTickets(pageParam);
    }, [location, userId]);

    // Listen for real-time ticket updates for the specific user
    useEffect(() => {
        const channel = window.Echo.channel('tickets').listen('TicketUpdated', (e) => {
            if (e.ticket.user_id === parseInt(userId)) {
                fetchUserTickets(currentPage); // Re-fetch tickets if the user's tickets are updated
            }
        });

        return () => {
            channel.stopListening('TicketUpdated');
        };
    }, [currentPage, userId]);

    return (
        <div className="container mx-auto p-4">
            <div className="flex justify-between items-center mb-4">
                <h2 className="text-xl font-bold">{`User Tickets`}</h2>
                <div>
                    <Link to="/tickets" className="mx-2 px-4 py-2 border rounded bg-gray-200">
                        Back to all tickets
                    </Link>
                </div>
            </div>

            {/* Show loading spinner or message while tickets are being fetched */}
            <TicketsTable tickets={tickets} />

            {/* Pagination Controls */}
            <div className="flex justify-center mt-4">
                {Array.from({ length: totalPages }, (_, index) => (
                    <button
                        key={index}
                        onClick={() => handlePageChange(index + 1)}
                        className={`mx-1 px-3 py-1 border rounded ${currentPage === index + 1 ? 'bg-blue-500 text-white' : 'bg-gray-200'}`}
                        disabled={loading} // Disable buttons while loading
                    >
                        {index + 1}
                    </button>
                ))}
            </div>
        </div>
    );
};

export default UserTickets;