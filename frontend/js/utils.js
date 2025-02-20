function renderListElements(list, elements, dataAttrName) {
    // list.innerHTML = '';
    elements.forEach(element => {
        const listItem = document.createElement('li');
        listItem.textContent = element.name;
        if (dataAttrName && element[dataAttrName]) {
            listItem.setAttribute(`data-${dataAttrName}`, element[dataAttrName]);
        }
        list.appendChild(listItem);
    });
}

export { renderListElements };