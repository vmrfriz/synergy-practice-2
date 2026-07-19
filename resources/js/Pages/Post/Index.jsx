import Pagination from "../../Components/Pagination.jsx";
import PostItem from "../../Components/PostItem/PostItem.jsx";
import SubscriptionButton from "../../Components/Subscriptions/SubscriptionButton.jsx";

export default function Index({ title, author, posts }) {
    return (
        <>
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h1 className="mb-0">{title}</h1>
            </div>

            <div className="mb-4">
                <SubscriptionButton user={author} />
            </div>

            {posts.data.length === 0 && (
                <div className="alert alert-light border">
                    Записей пока нет
                </div>
            )}

            <div className="d-flex flex-column gap-4">
                {posts.data.map((post) => (
                    <PostItem key={post.id} post={post}/>
                ))}
            </div>

            <div className="mt-4 d-flex justify-content-center">
                <Pagination links={posts.links}/>
            </div>
        </>
    );
}
