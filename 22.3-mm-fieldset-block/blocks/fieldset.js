const {__} = wp.i18n;
const {registerBlockType, createBlock} = wp.blocks;
const {RichText} = wp.blockEditor;

registerBlockType(
    'mm/fieldset',
    {
        title: 'Fieldset',
        category: 'widgets',
        icon: 'editor-kitchensink',
        keywords: [
            'MM',
            'Fieldset',
            'Label'
        ],
        supports: {
            multiple: true,
            align: true,
            className: true
        },
        attributes: {
            legend: {
                source: 'text',
                type: 'string',
                selector: 'legend'
            },
            content: {
                source: 'html',
                type: 'string',
                selector: 'div.content'
            }
        },
        edit: props => {
            const {attributes, setAttributes} = props;

            return <fieldset className="mm-fieldset">
                <RichText
                    tagName="legend"
                    value={attributes.legend}
                    placeholder={__('Enter a label', 'mfb')}
                    multiline={false}
                    onChange={(value) => {
                        setAttributes({legend: value})
                    }} /> <RichText
                tagName="div"
                className="content"
                value={attributes.content}
                placeholder={__('Enter some content', 'mfb')}
                multiline={false}
                onChange={(value) => {
                    setAttributes({content: value})
                }} />
            </fieldset>;
        },
        save: props => {
            const {attributes} = props;
            return <fieldset className="mm-fieldset">
                    <RichText.Content tagName="legend" value={attributes.legend} /> <RichText.Content tagName="div"
                    className="content" value={attributes.content} />
                </fieldset>;
        }
    }
);