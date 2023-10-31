import numpy as np

def matrix_inverse(matrix, mod):
    det = int(np.linalg.det(matrix))
    inv_det = None

    for i in range(1, mod):
        if (det * i) % mod == 1:
            inv_det = i
            break

    if inv_det is None:
        raise ValueError("Modular inverse does not exist.")

    adj_matrix = np.round(np.linalg.inv(matrix) * det)
    inverse_matrix = (adj_matrix % mod * inv_det) % mod
    return inverse_matrix.astype(int)

def hill_cipher(text, key, mode):
    mod = 26
    text = text.replace(" ", "").upper()
    text_len = len(text)

    if text_len % 2 != 0:
        text += "X"

    key_matrix = np.array(key)
    key_inverse = matrix_inverse(key_matrix, mod)

    if mode == "decrypt":
        key_matrix, key_inverse = key_inverse, key_matrix

    result = ""
    for i in range(0, text_len, 2):
        char_pair = [ord(text[i]) - ord("A"), ord(text[i + 1]) - ord("A")]
        encrypted_pair = np.dot(key_matrix, char_pair) % mod
        result += "".join([chr(val + ord("A")) for val in encrypted_pair])

    return result

key = [[2, 1], [3, 4]]
plaintext = "silvia"
encrypted_text = hill_cipher(plaintext, key, "encrypt")
decrypted_text = hill_cipher(encrypted_text, key, "decrypt")

print("Plaintext:", plaintext)
print("Encrypted Text:", encrypted_text)
print("Decrypted Text:", decrypted_text)
