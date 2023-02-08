export default ({ children }) => {
  return (
    <header className="bg-slate-800">
      <div className="mx-auto max-w-screen-xl px-4 py-2 sm:px-6 lg:px-8">
        <div className="flex items-center sm:justify-between sm:gap-4">
          {children}
        </div>
      </div>
    </header>
  );
};
