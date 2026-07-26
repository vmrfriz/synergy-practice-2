import { usePage } from "@inertiajs/react";

export default function Alerts({ className }) {
    const { flash, errors } = usePage().props;

    const flashArray = Object.entries(flash).filter((flash) => flash[1])
    const successTemplate = flashArray
        ? flashArray.map((flash) =>
            <div key={flash[0]} className={`alert alert-${flash[0]}`}>{flash[1]}</div>
        )
        : null

    const errorsArray = Object.entries(errors);
    const errorsTemplate = errorsArray.length
        ? <div className="alert alert-danger">
            <ul className="mb-0">
                {errorsArray.map((error) =>
                    <li key={error[0]}>{error[1]}</li>
                )}
            </ul>
        </div>
        : null

    return (successTemplate || errorsArray.length)
        ? <div className={`d-flex flex-column column-gap-3 ${className}`}>
            {successTemplate}
            {errorsTemplate}
        </div>
        : null
};
