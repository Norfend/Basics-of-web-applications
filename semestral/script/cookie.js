function setCookie(cookieName, cookieValue, expirationDays) {
    const date = new Date();
    date.setTime(date.getTime() + (expirationDays*24*60*60*1000));
    let expires = "expires="+ date.toUTCString();
    document.cookie = cookieName + "=" + cookieValue + "; " + expires + "; path=/";
}