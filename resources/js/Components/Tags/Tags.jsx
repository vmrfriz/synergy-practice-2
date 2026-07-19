import Tag from "./Tag";

export default function Tags({ tags, className }) {
    return (
        <div className={className || ''}>
            {tags?.map((tag) => (
                <Tag tag={tag} key={tag.id} />
            ))}
        </div>
    )
}
