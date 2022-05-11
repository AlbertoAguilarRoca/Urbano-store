

export const generatePassword = (length) => {

    const characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    let pass = '';

    for (let i=0; i < length; i++){
        pass += characters.charAt(Math.floor(Math.random()*characters.length));
    }

    return pass;
}