import { Link, useForm, usePage } from "@inertiajs/react";
import { subscribe, unsubscribe } from "../../route";

export default function SubscriptionButton({ user, className }) {
    const { post, processing, errors } = useForm();
    const { auth } = usePage().props;

    if (! auth.user) {
        return null;
    }

    const toggleSubscription = () => {
        const route = user.subscribed
            ? unsubscribe(user)
            : subscribe(user)
        post(route);
    }

    return (user &&
        <Link
            onClick={toggleSubscription}
            as="button"
            className={`btn ${user.subscribed ? 'btn-outline-secondary' : 'btn-primary'} ${className} ${processing ? 'progress-bar progress-bar-striped progress-bar-animated' : ''}`.trim()}
        >
            {user.subscribed ? 'Отписаться' : 'Подписаться'}
        </Link>
    );
}
