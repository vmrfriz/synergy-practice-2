import Subscription from "./Subscription";

export default function Subscriptions({ users, className }) {
    if (!users || users.length === 0) {
        return (
            <div className="text-muted">
                Вы ни на кого не подписаны.
            </div>
        );
    }

    return (
        <div className={`list-group ${className || ''}`}>
            {users.map((user) => (
                <Subscription user={user} key={user.id} />
            ))}
        </div>
    );
};
