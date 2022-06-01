module.exports = [
    {
        type: 'input',
        name: 'name',
        message: 'SCSS Stylesheet Name',
        validate(value) {
            if (!value.length) {
                return 'Stylesheet must have a name'
            }
            return true
        }
    },
    {
        type: 'select',
        name: 'folder',
        message: 'SCSS Folder',
        choices: ['components', 'mixins', 'scaffold', 'variables']
    },
]
