const formattedUserData = [],
    selectedOwners = [];

const getArrays = async callback => {
    const response =await fetch('http://localhost/DUBAI_PROJECT_CSV/dubai/apart_name.php');
    if (response.ok) {
        const usersData = await response.json();
        usersData.forEach((obj, idx) => {
            const newObj = {
                owner: obj.owner,
                apartNames: [obj.apart_name]
            }
            if (formattedUserData.length) {
                let ownerExistFlag = false
                for (let i = 0; i < formattedUserData.length; i++) {
                    const object = formattedUserData[i];
                    if (object.owner === obj.owner) {
                        formattedUserData[i].apartNames.push(obj.apart_name)
                        ownerExistFlag = true
                        break
                    }
                }
                if (!ownerExistFlag) formattedUserData.push(newObj)

            } else {
                formattedUserData.push(newObj)
            }
        })
        callback(formattedUserData);
    } else {
        console.error('Error: response status', response.status);
        return;
    }
}


const showArrays = users => {
    const selectAppartOwner = document.querySelector('#apart-owner'),
        selectAppartName = document.querySelector('#apart-name');
    users.forEach(user => {
        const newOptionOwner = document.createElement('option');
        newOptionOwner.value = user.owner;
        newOptionOwner.innerHTML = user.owner;
        selectAppartOwner.appendChild(newOptionOwner);

        user.apartNames.forEach(apartName => {
            const newOption = document.createElement('option');
            newOption.value = apartName;
            newOption.innerHTML = apartName;
            selectAppartName.appendChild(newOption);
        })
    })

    new MultiSelectTag('apart-owner');
    new MultiSelectTag('apart-name');

    const refreshApartNamesSelect = (node, action = 'add') => {
        const selectAppartName = document.querySelector('#apart-name'),
            ownerValue = node.querySelector('.item-label').dataset.value,
            selectedApartNamesArray = []; // there will be selected values

        // get multiple values from select: start
        let selectedApartNames = document.querySelector('#apart-name').nextElementSibling.querySelectorAll('.item-label');
        selectedApartNames.forEach(selectedApartName => {
            selectedApartNamesArray.push(selectedApartName.dataset.value)
        })
        // get multiple values from select: end

        if (action === 'add') {
            selectedOwners.push(ownerValue)
        } else if (action === 'remove') {
            selectedOwners.splice(selectedOwners.indexOf(ownerValue), 1)
        }

        selectAppartName.innerHTML = '';

        if (!selectedOwners.length) {
            formattedUserData.forEach(user => {
                user.apartNames.forEach((apartName, idx) => {
                    const newOption = document.createElement('option');
                    newOption.value = apartName;
                    newOption.innerHTML = apartName;
                    if (selectedApartNamesArray.some(el => el === apartName)) {
                        newOption.selected = true;
                    }
                    selectAppartName.appendChild(newOption);
                })
            })
        } else {
            selectedOwners.forEach(owner => {
                formattedUserData.forEach(user => {
                    if (user.owner === owner) {
                        const newOptGroup = document.createElement('optgroup');
                        newOptGroup.label = owner;

                        user.apartNames.forEach((apartName, idx) => {
                            const newOption = document.createElement('option');
                            newOption.value = apartName;
                            newOption.innerHTML = apartName;
                            if (selectedApartNamesArray.some(el => el === apartName)) {
                                newOption.selected = true;
                            }
                            newOptGroup.appendChild(newOption);

                            if (idx === user.apartNames.length - 1) selectAppartName.appendChild(newOptGroup)
                        })

                    }
                })
            })
        }

        const multiSelectApartName =  selectAppartName.nextElementSibling;
        multiSelectApartName.remove();
        new MultiSelectTag('apart-name');
    }

    const changeSelect = mutationList => {
        console.log('changeSelect')
        for (const mutation of mutationList) {
            let targetNode;
            if ([...mutation.addedNodes].some(node => {
                if (node.classList.contains('item-container')) {
                    targetNode = node;
                    return true;
                }
            })) {
                console.log('ADDED OWNER')
                refreshApartNamesSelect(targetNode, 'add')
            } else if ([...mutation.removedNodes].some(node => {
                if (node.classList.contains('item-container')) {
                    targetNode = node;
                    return true;
                }
            })) {
                console.log('REMOVED OWNER')
                refreshApartNamesSelect(targetNode, 'remove')
            }
        }
    };
    const multiSelectApartOwner =  selectAppartOwner.nextElementSibling;
    console.log('multiSelectApartOwner', multiSelectApartOwner)
    const observer = new MutationObserver(changeSelect)
    observer.observe(multiSelectApartOwner, {
        childList: true,
        subtree: true,
        attributes: true
    })
    console.log('observer', observer)
}

document.addEventListener('DOMContentLoaded', getArrays.bind(null, showArrays))
// new MultiSelectTag('test')