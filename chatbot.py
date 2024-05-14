import json
import random
import pickle
import numpy as np
from datetime import datetime

import nltk
from nltk.stem import WordNetLemmatizer
from tensorflow import keras

from flask import Flask, request, jsonify
import sys

app = Flask(__name__)


# Load model and data
lemmatizer = WordNetLemmatizer()
model = keras.models.load_model("./chatbot/chatbot_model.h5")
classes = pickle.load(open('./chatbot/classes.pkl', 'rb'))
intents = json.loads(open("./chatbot/intents.json").read())
words = pickle.load(open('./chatbot/words.pkl', 'rb'))

# Function to clean up sentence
def clean_up_sentence(sentence):
    sentence_words = nltk.word_tokenize(sentence)
    sentence_words = [lemmatizer.lemmatize(word.lower()) for word in sentence_words]
    return sentence_words

# Function to create bag of words
def bag_of_words(sentence):
    sentence_words = clean_up_sentence(sentence)
    bag = [0] * len(words)
    for w in sentence_words:
        for i, word in enumerate(words):
            if word == w:
                bag[i] = 1
    return np.array(bag)

# Function to predict class
def predict_class(sentence):
    bow = bag_of_words(sentence)
    res = model.predict(np.array([bow]))[0]
    ERROR_THRESHOLD = 0.25
    results = [[i, r] for i, r in enumerate(res) if r > ERROR_THRESHOLD]

    results.sort(key=lambda x: x[1], reverse=True)
    return_list = []
    for r in results:
        return_list.append({'intent': classes[r[0]], 'probability': str(r[1])})
    
    # Tambahkan penanganan khusus untuk intent "datetime"
    if return_list[0]['intent'] == 'datetime':
        # Cek jika tidak ada kata kunci yang spesifik
        if all(word not in sentence for word in ['date', 'year', 'month']):
            # Set default intent ke 'date'
            return_list[0]['intent'] = 'date'
    return return_list

def get_date_time():
    now = datetime.now()
    date = now.strftime("%d")
    month = now.strftime("%B")
    year = now.strftime("%Y")
    return date, month, year

def get_day():
    now = datetime.now()
    day = now.strftime("%A")
    return day

# Function to get response
def get_response(intents_list, intents_json, user_name=""):
    tag = intents_list[0]['intent']
    list_of_intents = intents_json['intents']
    response = ""
    for intent in list_of_intents:
        if intent['tag'] == tag:
            if tag == "date":
                day = get_day()
                response = intent['responses'][0].replace("[day]", day)
                break
            elif tag == "date":
                date, month, year = get_date_time()
                response = intent['responses'][0].replace("[date]", date).replace("[month]", month).replace("[year]", year)
                break
            elif tag == "year":
                _, _, year = get_date_time()
                response = intent['responses'][0].replace("[year]", year)
                break
            elif tag == "month":
                _, month, _ = get_date_time()
                response = intent['responses'][0].replace("[month]", month)
                break
            else:
                response = random.choice(intent['responses'])
                break
            
    # Periksa apakah placeholder [name] ada dalam respons sebelum mencoba menggantinya
    if "[name]" in response:
        response = response.replace("[name]", user_name)
    
    # Ganti placeholder [date], [month], dan [year] dengan nilai yang sesuai
    response = response.replace("[date]", str(get_date_time()[0]))
    response = response.replace("[month]", str(get_date_time()[1]))
    response = response.replace("[year]", str(get_date_time()[2]))
    
    return response

# Define routes
@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()
    message = data['message']
    name_tag = "name"
    if name_tag in message:
        user_name = message.split(name_tag)[-1].strip()
    else:
        user_name = ""
    ints = predict_class(message)
    res = get_response(ints, intents, user_name=user_name)
    return jsonify({'response': res})

if sys.argv[0]:
    if __name__ == "__main__":
        app.run(debug=True)