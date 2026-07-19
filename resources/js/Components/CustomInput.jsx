export default function CustomInput({ children, value, onChange, error, type = 'text', placeholder }) {
    return (
        <div className="mb-3">
            <label className="form-label">{children}</label>

            <input
                type={type}
                className="form-control"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                placeholder={placeholder}
            />

            {error && (
                <div className="text-danger small mt-1">
                    {error}
                </div>
            )}
        </div>
    );
}
