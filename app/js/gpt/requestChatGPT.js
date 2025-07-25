

function requestChatGPT(prompt, key, callback) {
  //console.log( prompt );

    const data = {
        messages: [
          {
            content: prompt,
            role: "system",
          },
        ],
        //model: 'gpt-4',
        model: 'ft:gpt-4o-mini-2024-07-18:personal::B3X8ZQfX',
        temperature: 0.5,
        max_tokens: 4000,
        top_p: 1,
        frequency_penalty: 0.5,
        presence_penalty: 0,
      };
    fetch('https://api.openai.com/v1/chat/completions', {
        method: "POST",
        headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${OPENAI_API_KEYS}`,
    },
    body: JSON.stringify(data),
    })
    .then((response) => response.json())
    .then((json) => {

    if (json.error?.message) {
        var text = "Ocorreu um erro. Tente Novamente!"
    } else if (json.choices?.[0].message.content) {
        var text = json.choices[0].message.content || "Sem resposta";
        text = text.replaceAll("**", "<b>")
        callback(text);
    }

    })
    .catch((error) => console.error("Error:", error))
    .finally((m) => {console.log("Fim", m) });
}

