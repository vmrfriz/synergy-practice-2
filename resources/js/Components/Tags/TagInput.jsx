import CreatableSelect from 'react-select/creatable';

export default function TagInput({
    tags,
    value,
    onChange,
}) {
    const options = tags.map(tag => ({
        value: tag,
        label: tag,
    }));

    return (
        <CreatableSelect
            isMulti
            options={options}
            value={value.map(tag => ({
                value: tag,
                label: tag,
            }))}
            onChange={(items) => {
                const unique = [...new Set(
                    items.map(item => item.value.trim().toLowerCase())
                )];

                onChange(unique);
            }}
            placeholder="Выберите или создайте теги..."
            noOptionsMessage={() => 'Ничего не найдено'}
            formatCreateLabel={(value) => `Создать "${value}"`}
        />
    );
}
