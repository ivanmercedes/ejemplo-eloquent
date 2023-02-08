import { useRef, useState } from "react";
import moment from "moment";

import Header from "../components/Header";
import Spinner from "../components/Spinner";

moment.locale("es-do");

const Home = () => {
  const messagesDivRef = useRef(null);

  const [state, setState] = useState({
    tickets: null,
    isLoading: false,
    isActive: null,
    ticketDetails: null,
  });
  const [searchTerm, setSearchTerm] = useState("");

  const handleOnSumit = async (e) => {
    // Actualizar el estado aquí...
    e.preventDefault();
    setState({
      ...state,
      isLoading: true,
    });

    const data = await fetch("http://localhost:8000/messages?s=" + searchTerm);
    const tickets = await data.json();
    setState({
      ...state,
      tickets,
      isLoading: false,
    });
  };

  const onShowTicket = async (id) => {
    const data = await fetch("http://localhost:8000/cases/" + id);
    const tickets = await data.json();

    setState({
      ...state,
      ticketDetails: tickets,
      isActive: id,
    });

    // Luego, mover el scroll del div al top
    messagesDivRef.current.scrollTo(0, 0);
  };

  if (state.isLoading) return <Spinner />;
  return (
    <>
      <Header>
        <form onSubmit={handleOnSumit} className="relative  w-full">
          <label className="sr-only" htmlFor="search">
            Buscar
          </label>

          <input
            value={searchTerm}
            onChange={(event) => setSearchTerm(event.target.value)}
            className="h-14 w-full rounded-lg border-none bg-slate-900 pl-4 pr-10 text-md shadow-sm outline-0 text-gray-200 "
            id="search"
            type="text"
            placeholder="Buscar..."
          />

          <button
            type="submit"
            className="absolute top-1/2 right-2 -translate-y-1/2 rounded-md bg-slate-800 p-2 text-gray-600 transition hover:text-gray-700"
          >
            <span className="sr-only">Buscar</span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              strokeWidth="2"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
          </button>
        </form>
      </Header>

      <div className="flex flex-wrap flex-row w-full h-full">
        <section
          className={`flex flex-col p-4 w-full max-w-sm flex-none  min-h-0 overflow-auto overflow-y-auto max-h-[calc(100vh_-_70px)]`}
        >
          <ul>
            {state.tickets &&
              state.tickets.map(
                ({
                  uuid,
                  subject,
                  last_message_preview,
                  caseid,
                  createdat,
                }) => (
                  <li key={uuid} onClick={() => onShowTicket(caseid)}>
                    <article
                      tabIndex="0"
                      className={`cursor-pointer shadow   rounded-md p-3 bg-slate-800 flex text-gray-200 font-bold mb-2  focus:outline-none   ${
                        state.isActive === caseid ? "border-2 border-green-500" : null
                      }`}
                    >
                      <div className="flex-1">
                        <header className="mb-1">
                          <h1 className="inline break-all text-slate-400">
                            {subject}
                          </h1>
                        </header>
                        <p className="text-gray-200 font-normal break-all">
                          {last_message_preview}
                        </p>
                        <footer className="text-gray-500 mt-2 text-sm">
                          {
                            moment.unix(createdat, "YYYYMMDD").fromNow()
                            // .format("DD/MM/YYYY")
                          }
                        </footer>
                      </div>
                    </article>
                  </li>
                ),
              )}
          </ul>
        </section>

        {state.ticketDetails && (
          <section
            ref={messagesDivRef}
            className="flex  flex-col flex-auto border-slate-800  w-3/5 p-3 border-l-2 overflow-y-auto max-h-[calc(100vh_-_70px)]"
          >
            <div className="w-full">
              <p className="break-all">
                <div class=" p-4 rounded-lg">
                  {state?.ticketDetails?.messages.map(({ messages }) => (
                    <div class="text-gray-700 bg-slate-800 shadow rounded-lg p-4 mb-4">
                      <div className="mb-2 flex justify-between">
                        <span className="text-slate-400 font-bold">
                          {messages.fullname} - {messages.email}
                        </span>

                        <span className="text-slate-400">
                          {
                            moment
                              .unix(messages.createdat, "YYYYMMDD")
                              .fromNow()
                            // .format("DD/MM/YYYY")
                          }
                        </span>
                      </div>
                      <hr className=" border-slate-500 py-2" />
                      <p
                        dangerouslySetInnerHTML={{
                          __html:
                            messages.html === ""
                              ? messages.text
                              : messages.html,
                        }}
                        className="text-slate-200"
                      ></p>
                    </div>
                  ))}
                </div>
              </p>
            </div>
          </section>
        )}
      </div>
    </>
  );
};

export default Home;
